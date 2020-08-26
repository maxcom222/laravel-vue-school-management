import { Channel, PresenceChannel } from './../channel';
import EchoOptions from '../echoOptions';
export declare abstract class Connector {
    private _defaultOptions;
    options: EchoOptions;
    constructor(options: EchoOptions);
    protected setOptions(options: EchoOptions): any;
    protected csrfToken(): string | null;
    abstract connect(): void;
    abstract listen(name: string, event: string, callback: Function): Channel;
    abstract channel(channel: string): Channel;
    abstract privateChannel(channel: string): Channel;
    abstract presenceChannel(channel: string): PresenceChannel;
    abstract leave(channel: string): void;
    abstract socketId(): string;
    abstract disconnect(): void;
}
