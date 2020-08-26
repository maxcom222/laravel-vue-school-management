import { PresenceChannel, SocketIoPrivateChannel } from './';
export declare class SocketIoPresenceChannel extends SocketIoPrivateChannel implements PresenceChannel {
    here(callback: Function): SocketIoPresenceChannel;
    joining(callback: Function): SocketIoPresenceChannel;
    leaving(callback: Function): SocketIoPresenceChannel;
}
