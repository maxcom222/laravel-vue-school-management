import { Channel } from './channel';
export declare class NullChannel extends Channel {
    subscribe(): any;
    unsubscribe(): void;
    listen(event: string, callback: Function): NullChannel;
    stopListening(event: string): NullChannel;
    on(event: string, callback: Function): NullChannel;
}
