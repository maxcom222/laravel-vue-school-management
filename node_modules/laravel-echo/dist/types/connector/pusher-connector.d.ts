/// <reference types="pusher-js" />
import { Connector } from './connector';
import { PusherChannel, PusherPresenceChannel } from './../channel';
export declare class PusherConnector extends Connector {
    pusher: Pusher.Pusher;
    channels: {
        [key: string]: PusherChannel;
    };
    connect(): void;
    listen(name: string, event: string, callback: Pusher.EventCallback): PusherChannel;
    channel(name: string): PusherChannel;
    privateChannel(name: string): PusherChannel;
    presenceChannel(name: string): PusherPresenceChannel;
    leave(name: string): void;
    socketId(): string;
    disconnect(): void;
}
