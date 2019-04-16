import { Injectable } from '@angular/core';
import {Observable} from 'rxjs';
import {Debit} from '../models/Debit';
import {HttpClient, HttpHeaders} from '@angular/common/http';

const httpOptions = {
    headers: new HttpHeaders({
        'Content-Type': 'application/json'
    })
};

@Injectable({
  providedIn: 'root'
})
export class DebitService {

    endpoint = '/api/debit';

    constructor(private http: HttpClient) { }

    getDebits(): Observable<Debit[]> {
        return this.http.get<Debit[]>(`${this.endpoint}`);
    }

    deleteDebit(debit: Debit): Observable<Debit> {
        const url = `${this.endpoint}/${debit.id}`;
        return this.http.delete<Debit>(url, httpOptions);
    }

    addDebit(debit: any): Observable<Debit> {
        return this.http.post<Debit>(this.endpoint, debit, httpOptions);
    }

    updateDebit(debit: Debit): Observable<Debit> {
        const url = `${this.endpoint}/${debit.id}`;
        return this.http.put<Debit>(url, debit, httpOptions);
    }

}
