import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DaftarCustomerComponent } from './daftar-customer.component';

describe('DaftarCustomerComponent', () => {
  let component: DaftarCustomerComponent;
  let fixture: ComponentFixture<DaftarCustomerComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DaftarCustomerComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DaftarCustomerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
