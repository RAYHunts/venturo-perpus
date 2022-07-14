import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DaftarUserComponent } from './daftar-user.component';

describe('DaftarUserComponent', () => {
  let component: DaftarUserComponent;
  let fixture: ComponentFixture<DaftarUserComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DaftarUserComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DaftarUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
