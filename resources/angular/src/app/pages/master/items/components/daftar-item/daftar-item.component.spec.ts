import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DaftarItemComponent } from './daftar-item.component';

describe('DaftarItemComponent', () => {
  let component: DaftarItemComponent;
  let fixture: ComponentFixture<DaftarItemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DaftarItemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DaftarItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
