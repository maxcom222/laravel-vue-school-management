export declare class EventFormatter {
    namespace: string | boolean;
    constructor(namespace: string | boolean);
    format(event: string): string;
    setNamespace(value: string | boolean): void;
}
