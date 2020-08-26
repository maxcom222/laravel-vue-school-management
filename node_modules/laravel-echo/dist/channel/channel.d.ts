/**
 * This class represents a basic channel.
 */
export declare abstract class Channel {
    /**
     * The Echo options.
     */
    options: any;
    /**
     * Listen for an event on the channel instance.
     */
    abstract listen(event: string, callback: Function): Channel;
    /**
     * Listen for a whisper event on the channel instance.
     */
    listenForWhisper(event: string, callback: Function): Channel;
    /**
     * Listen for an event on the channel instance.
     */
    notification(callback: Function): Channel;
    /**
     * Stop listening to an event on the channel instance.
     */
    abstract stopListening(event: string): Channel;
}
