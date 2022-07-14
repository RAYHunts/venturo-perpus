import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListBorrowComponent } from './list-borrow.component';

describe('ListBorrowComponent', () => {
  let component: ListBorrowComponent;
  let fixture: ComponentFixture<ListBorrowComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ListBorrowComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListBorrowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
