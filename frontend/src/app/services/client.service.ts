import { Injectable } from '@angular/core';
import {Client} from '../models/Client';
import {Debit} from '../models/Debit';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ClientService {

  endpoint = '/api/users';

  constructor(private http: HttpClient) { }

  getClients(): Observable<Client[]> {
      return this.http.get<Client[]>(`${this.endpoint}`);
  }

}
