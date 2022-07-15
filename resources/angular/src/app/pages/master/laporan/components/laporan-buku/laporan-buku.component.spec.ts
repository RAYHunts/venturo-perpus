import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LaporanBukuComponent } from './laporan-buku.component';

describe('LaporanBukuComponent', () => {
  let component: LaporanBukuComponent;
  let fixture: ComponentFixture<LaporanBukuComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LaporanBukuComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LaporanBukuComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
