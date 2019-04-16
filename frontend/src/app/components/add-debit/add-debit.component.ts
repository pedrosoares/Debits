import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Client} from '../../models/Client';
import {ClientService} from '../../services/client.service';
import {ToastrService} from 'ngx-toastr';
import {DebitService} from '../../services/debit.service';

@Component({
  selector: 'app-add-debit',
  templateUrl: './add-debit.component.html'
})
export class AddDebitComponent implements OnInit {

    @Input() clients: Array<Client>;
    @Output() addDebit: EventEmitter<any> = new EventEmitter<any>();

    clientId: number;
    reason: string;
    value: number;
    date: string;

    disabledSubmit: boolean;

    constructor(private debitService: DebitService, private toastr: ToastrService) {}

    ngOnInit() {
        // Set default property value
        this.disabledSubmit = false;
    }

    onSubmit() {
        if (this.clientId == null) {
            this.toastr.error('O campo "cliente" é obrigatório', 'Erro');
            return;
        }
        if (this.reason == null) {
            this.toastr.error('O campo "motivo" é obrigatório', 'Erro');
            return;
        }
        if (this.value == null) {
            this.toastr.error('O campo "valor" é obrigatório', 'Erro');
            return;
        }
        if (this.date == null) {
            this.toastr.error('O campo "data" é obrigatório', 'Erro');
            return;
        }

        const debitPrototype = {
            client_id: this.clientId,
            reason: this.reason,
            value: this.value,
            date: this.date
        };

        this.disabledSubmit = true;

        this.debitService.addDebit(debitPrototype).subscribe(debit => {
            this.disabledSubmit = false;
            this.addDebit.emit(debit);
            this.toastr.success('Débito criado com sucesso');
        });
    }

    setClasses() {
        if (this.disabledSubmit) {
            return 'w-full text-center py-3 rounded bg-grey-light text-grey-dark my-1';
        }
        return 'w-full text-center py-3 rounded bg-green text-white hover:bg-green-dark focus:outline-none my-1';
    }

}
