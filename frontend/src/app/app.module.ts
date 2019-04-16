import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { HttpClientModule } from '@angular/common/http';
import { HeaderComponent } from './components/layout/header/header.component';
import { AppRoutingModule } from './app-routing.module';
import { AddDebitComponent } from './components/add-debit/add-debit.component';
import { DebitItemComponent } from './components/debit-item/debit-item.component';
import { DebitsComponent } from './components/debits/debits.component';
import { CurrencyMaskModule } from 'ng2-currency-mask';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ToastrModule } from 'ngx-toastr';
import { EditDebitComponent } from './components/edit-debit/edit-debit.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    AddDebitComponent,
    DebitItemComponent,
    DebitsComponent,
    EditDebitComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    FormsModule,
    AppRoutingModule,
    CurrencyMaskModule,
    BrowserAnimationsModule,
    ToastrModule.forRoot()
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
