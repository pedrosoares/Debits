import { Component, OnInit } from '@angular/core';
import {Debit} from '../../models/Debit';
import {DebitService} from '../../services/debit.service';
import {ClientService} from '../../services/client.service';
import {Client} from '../../models/Client';

@Component({
  selector: 'app-debits',
  templateUrl: './debits.component.html'
})
export class DebitsComponent implements OnInit {

    clients: Array<Client>;
    debits: Debit[];
    debit: Debit;

    constructor(private debitService: DebitService, private clientService: ClientService) { }

    ngOnInit() {
        // Debit to edit
        this.debit = null;
        // Get List of Debits from Service
        this.debitService.getDebits().subscribe(debits => {
            this.debits = debits;
        });
        // Get List of Clients from Service
        this.clientService.getClients().subscribe(clients => {
            this.clients = clients;
        });
    }

    editDebit(debit: Debit) {
        this.debit = debit;
    }

    deleteDebit(debit: Debit) {
        // remove from UI
        this.debits = this.debits.filter(t => t.id !== debit.id);
        // Clean for safety
        this.debit = null;
    }

    updateDebit(debit: Debit) {
        this.debit = null;
    }

    addDebit(debit: Debit) {
        // add debit to UI
        this.debits.push(debit);
        // Clean for safety
        this.debit = null;
    }

}
