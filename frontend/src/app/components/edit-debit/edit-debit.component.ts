import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {DebitService} from '../../services/debit.service';
import {ToastrService} from 'ngx-toastr';
import {Client} from '../../models/Client';
import {Debit} from '../../models/Debit';

@Component({
  selector: 'app-edit-debit',
  templateUrl: './edit-debit.component.html'
})
export class EditDebitComponent implements OnInit {

    @Input() clients: Array<Client>;
    @Input() debit: Debit;
    @Output() updateDebit: EventEmitter<Debit> = new EventEmitter<Debit>();

    clientId: number;
    reason: string;
    value: number;
    date: string;

    disabledSubmit: boolean;

    constructor(private debitService: DebitService, private toastr: ToastrService) {}

    ngOnInit() {
        // Set default property value
        this.disabledSubmit = false;

        this.clientId = this.debit.client_id;
        this.reason = this.debit.reason;
        this.value = this.debit.value;
        this.date = this.debit.date.slice(0, 10);
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

        const debitPrototype: Debit = {
            id: this.debit.id,
            client_id: this.clientId,
            reason: this.reason,
            value: this.value,
            date: this.date
        };

        this.disabledSubmit = true;

        this.debitService.updateDebit(debitPrototype).subscribe(debit => {
            this.disabledSubmit = false;

            this.updateDebit.emit(debit);

            this.debit.client_id = debit.client_id;
            this.debit.client = debit.client;
            this.debit.reason = debit.reason;
            this.debit.value = debit.value;
            this.debit.date = debit.date;

            this.toastr.success('Débito atualizado com sucesso');
        });
    }

    setClasses() {
        if (this.disabledSubmit) {
            return 'w-full text-center py-3 rounded bg-grey-light text-grey-dark my-1';
        }
        return 'w-full text-center py-3 rounded bg-green text-white hover:bg-green-dark focus:outline-none my-1';
    }

}
