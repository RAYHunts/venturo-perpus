import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DaftarRolesComponent } from './daftar-roles.component';

describe('DaftarRolesComponent', () => {
  let component: DaftarRolesComponent;
  let fixture: ComponentFixture<DaftarRolesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DaftarRolesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DaftarRolesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
