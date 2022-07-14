import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

import { PerfectScrollbarModule } from 'ngx-perfect-scrollbar';

import { NgbDropdownModule } from '@ng-bootstrap/ng-bootstrap';
import { ClickOutsideModule } from 'ng-click-outside';

import { LayoutComponent } from './layout.component';
import { FooterComponent } from './footer/footer.component';
import { HorizontalComponent } from './horizontal/horizontal.component';
import { HorizontaltopbarComponent } from './horizontaltopbar/horizontaltopbar.component';
import { PageTitleComponent } from './shared/page-title/page-title.component';

@NgModule({
  // tslint:disable-next-line: max-line-length
  declarations: [LayoutComponent, FooterComponent, HorizontalComponent, HorizontaltopbarComponent, PageTitleComponent],
  imports: [
    CommonModule,
    RouterModule,
    NgbDropdownModule,
    ClickOutsideModule,
    PerfectScrollbarModule,
  ],
  exports: [PageTitleComponent]
})
export class LayoutsModule { }
