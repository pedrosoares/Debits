import {Component, OnInit, Input, Output, EventEmitter} from '@angular/core';
import {Debit} from '../../models/Debit';
import {DebitService} from '../../services/debit.service';
import {ToastrService} from 'ngx-toastr';

@Component({
  selector: 'app-debit-item',
  templateUrl: './debit-item.component.html'
})
export class DebitItemComponent implements OnInit {

    @Input() debit: Debit;
    @Output() deleteDebit: EventEmitter<Debit> = new EventEmitter<Debit>();
    @Output() editDebit: EventEmitter<Debit> = new EventEmitter<Debit>();

    disableDelete: boolean;
    detail: boolean;

    constructor(private debitService: DebitService, private toastr: ToastrService) { }

    ngOnInit() {
        this.disableDelete = false;
    }

    toggleDetail() {
        this.detail = !this.detail;
    }

    onEdit(debit: Debit) {
        this.editDebit.emit(debit);
    }

    onDelete(debit: Debit) {
        this.disableDelete = true;
        // remove from the Server
        this.debitService.deleteDebit(debit).subscribe((response: any) => {
            // Show Success Message
            this.toastr.success(response.success);
            // Tell Parent to update UI
            this.deleteDebit.emit(debit);
        });
    }

    setClasses() {
        if (this.disableDelete) {
            return 'text-grey-lighter no-underline font-bold py-1 px-3 rounded text-xs bg-grey-light text-grey-dark';
        }
        return 'text-grey-lighter no-underline font-bold py-1 px-3 rounded text-xs bg-red hover:bg-red-dark';
    }

}
