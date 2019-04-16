import {Client} from './Client';

export class Debit {
    id: number;
    client_id: number;
    reason: string;
    value: number;
    date: string;
    date_formatted?: string;
    client?: Client;
}
