import { Connector } from './connector';
import { NullChannel, NullPrivateChannel, PresenceChannel } from './../channel';
export declare class NullConnector extends Connector {
    channels: any;
    connect(): void;
    listen(name: string, event: string, callback: Function): NullChannel;
    channel(name: string): NullChannel;
    privateChannel(name: string): NullPrivateChannel;
    presenceChannel(name: string): PresenceChannel;
    leave(name: string): void;
    socketId(): string;
    disconnect(): void;
}
