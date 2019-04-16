import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditDebitComponent } from './edit-debit.component';

describe('EditDebitComponent', () => {
  let component: EditDebitComponent;
  let fixture: ComponentFixture<EditDebitComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditDebitComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditDebitComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
