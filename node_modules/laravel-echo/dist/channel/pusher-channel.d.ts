import { EventFormatter } from './../util';
import { Channel } from './channel';
/**
 * This class represents a Pusher channel.
 */
export declare class PusherChannel extends Channel {
    /**
     * The Pusher client instance.
     */
    pusher: any;
    /**
     * The name of the channel.
     */
    name: any;
    /**
     * Channel options.
     */
    options: any;
    /**
     * The event formatter.
     */
    eventFormatter: EventFormatter;
    /**
     * The subsciption of the channel.
     */
    subscription: any;
    /**
     * Create a new class instance.
     */
    constructor(pusher: any, name: any, options: any);
    /**
     * Subscribe to a Pusher channel.
     */
    subscribe(): any;
    /**
     * Unsubscribe from a Pusher channel.
     */
    unsubscribe(): void;
    /**
     * Listen for an event on the channel instance.
     */
    listen(event: string, callback: Function): PusherChannel;
    /**
     * Stop listening for an event on the channel instance.
     */
    stopListening(event: string): PusherChannel;
    /**
     * Bind a channel to an event.
     */
    on(event: string, callback: Function): PusherChannel;
}
