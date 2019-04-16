import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DebitItemComponent } from './debit-item.component';

describe('DebitItemComponent', () => {
  let component: DebitItemComponent;
  let fixture: ComponentFixture<DebitItemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DebitItemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DebitItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
