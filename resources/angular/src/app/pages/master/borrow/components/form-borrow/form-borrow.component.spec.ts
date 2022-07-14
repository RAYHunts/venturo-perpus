import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FormBorrowComponent } from './form-borrow.component';

describe('FormBorrowComponent', () => {
  let component: FormBorrowComponent;
  let fixture: ComponentFixture<FormBorrowComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FormBorrowComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FormBorrowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
