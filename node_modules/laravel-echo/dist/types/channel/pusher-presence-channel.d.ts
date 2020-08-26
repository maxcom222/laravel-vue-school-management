import { PusherChannel } from './pusher-channel';
import { PresenceChannel } from './presence-channel';
export declare class PusherPresenceChannel extends PusherChannel implements PresenceChannel {
    here(callback: Function): PusherPresenceChannel;
    joining(callback: Function): PusherPresenceChannel;
    leaving(callback: Function): PusherPresenceChannel;
    whisper(eventName: any, data: any): PusherPresenceChannel;
}
