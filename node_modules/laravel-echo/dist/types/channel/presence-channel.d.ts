export interface PresenceChannel {
    here(callback: Function): PresenceChannel;
    joining(callback: Function): PresenceChannel;
    leaving(callback: Function): PresenceChannel;
}
