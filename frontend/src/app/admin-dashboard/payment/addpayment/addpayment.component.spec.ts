import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddpaymentComponent } from './addpayment.component';

describe('AddpaymentComponent', () => {
  let component: AddpaymentComponent;
  let fixture: ComponentFixture<AddpaymentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AddpaymentComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(AddpaymentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
