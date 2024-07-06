const currentScript = document.getElementById("livewire-beacon");

const channelName = currentScript.dataset.channel || "beacon-channel";
const inboundEvent = currentScript.dataset.inbound || "BeaconInboundEvent";
const outboundEvent = currentScript.dataset.outbound || "BeaconOutboundEvent";

const pendingCommits = new Map();

const shouldIntercept = () => {
    if (
        Echo.connector.pusher.connection &&
        Echo.connector.pusher.connection.state === "connected" &&
        Echo.connector.channels[channelName]
    ) {
        return true;
    }

    return false;
};

document.addEventListener("livewire:init", () => {
    Livewire.hook("commit.pooling", ({ commits }) => {
        if (!shouldIntercept()) {
            return;
        }

        Array.from(commits).forEach((commit) => {
            commit.prepare();

            const id = Math.random().toString(36);
            const [payload, succeed, fail] = commit.toRequestPayload();

            pendingCommits.set(id, { commit, succeed, fail });

            return new Promise((resolve, reject) => {
                Echo.connector.pusher.connection.send(
                    JSON.stringify({
                        event: inboundEvent,
                        data: {
                            id,
                            payload,
                        },
                    })
                );

                resolve();
            });
        });

        commits.clear();
    });
});

const channel = Echo.channel(channelName);
channel.listen(`.${outboundEvent}`, async (e) => {
    const {
        id,
        result: { components, assets },
    } = e;

    await Livewire.triggerAsync("payload.intercept", { components, assets });

    if (!pendingCommits.get(id)) {
        return;
    }

    const { succeed } = pendingCommits.get(id);

    if (components.length > 0) {
        succeed(components[0]);
    }

    pendingCommits.delete(id);
});
