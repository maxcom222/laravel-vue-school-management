/// <reference types="pusher-js" />
import { EventFormatter } from './../util';
import { Channel } from './channel';
import EchoOptions from '../echoOptions';
export declare class PusherChannel extends Channel {
    pusher: Pusher.Pusher;
    name: string;
    options: EchoOptions;
    eventFormatter: EventFormatter;
    subscription: Pusher.Channel;
    constructor(pusher: Pusher.Pusher, name: string, options: EchoOptions);
    subscribe(): any;
    unsubscribe(): void;
    listen(event: string, callback: Pusher.EventCallback): PusherChannel;
    stopListening(event: string): PusherChannel;
    on(event: string, callback: Pusher.EventCallback): PusherChannel;
}
