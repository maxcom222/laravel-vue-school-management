/// <reference types="socket.io-client" />
import { EventFormatter } from './../util';
import { Channel } from './channel';
import EchoOptions from '../echoOptions';
export declare class SocketIoChannel extends Channel {
    socket: SocketIOClient.Socket;
    name: string;
    options: EchoOptions;
    eventFormatter: EventFormatter;
    events: {
        [key: string]: Function[];
    };
    constructor(socket: any, name: string, options: EchoOptions);
    subscribe(): any;
    unsubscribe(): void;
    listen(event: string, callback: Function): SocketIoChannel;
    on(event: string, callback: Function): void;
    configureReconnector(): void;
    bind(event: string, callback: Function): void;
    unbind(): void;
}
