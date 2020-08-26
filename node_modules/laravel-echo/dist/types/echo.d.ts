import { Connector } from './connector';
import { Channel, PresenceChannel } from './channel';
import EchoOptions from './echoOptions';
export default class Echo {
    connector: Connector;
    options: EchoOptions;
    constructor(options: EchoOptions);
    registerVueRequestInterceptor(): void;
    registerAxiosRequestInterceptor(): void;
    registerjQueryAjaxSetup(): void;
    listen(channel: string, event: string, callback: Function): Channel;
    channel(channel: string): Channel;
    private(channel: string): Channel;
    join(channel: string): PresenceChannel;
    leave(channel: string): void;
    socketId(): string;
    disconnect(): void;
}
