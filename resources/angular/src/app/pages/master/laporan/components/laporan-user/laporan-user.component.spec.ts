import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LaporanUserComponent } from './laporan-user.component';

describe('LaporanUserComponent', () => {
  let component: LaporanUserComponent;
  let fixture: ComponentFixture<LaporanUserComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LaporanUserComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LaporanUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
