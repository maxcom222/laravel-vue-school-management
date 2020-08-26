import EchoOptions from "../echoOptions";
export declare abstract class Channel {
    options: EchoOptions;
    abstract listen(event: string, callback: Function): Channel;
    notification(callback: Function): Channel;
    listenForWhisper(event: string, callback: Function): Channel;
}
