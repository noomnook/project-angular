import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { AddMemberComponent } from './components/add-member/add-member.component';
import { MemberListComponent } from './components/member-list/member-list.component';
import { MemberDetailComponent } from './components/member-detail/member-detail.component';

const routes: Routes = [
  {path: '', pathMatch: 'full', redirectTo:'member-list'},
  {path: 'add-member', component: AddMemberComponent},
  {path: 'member-list', component: MemberListComponent},  
  {path: 'member-detail/:member_id', component: MemberDetailComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
