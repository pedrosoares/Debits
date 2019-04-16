import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { DebitsComponent } from './components/debits/debits.component';

const routes: Routes = [
    {path: '', component: DebitsComponent}
];

@NgModule({
    declarations: [],
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule { }
