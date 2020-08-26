import { NullChannel } from './null-channel';
import { PresenceChannel } from './presence-channel';
export declare class NullPresenceChannel extends NullChannel implements PresenceChannel {
    here(callback: Function): NullPresenceChannel;
    joining(callback: Function): NullPresenceChannel;
    leaving(callback: Function): NullPresenceChannel;
    whisper(eventName: any, data: any): NullPresenceChannel;
}
