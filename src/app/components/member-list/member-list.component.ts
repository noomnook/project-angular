import { Component, OnInit } from '@angular/core';
import { MemberService } from "./../../service/member.service";

@Component({
  selector: 'app-member-list',
  templateUrl: './member-list.component.html',
  styleUrls: ['./member-list.component.css']
})
export class MemberListComponent implements OnInit {

  Members: any = [];
  constructor(private memberService: MemberService) { }

  ngOnInit(): void {
    this.memberService.getMembers().subscribe(res => {
      // console.log("C TS >: " + JSON.stringify(res))
      this.Members = res;
    })
  }

  deleteMember(member_id:any, i:any){
    console.log(member_id)
    if(window.confirm('Do you want to delete?')){
      this.memberService.deleteMember(member_id).subscribe((res) => {
        // splice 1 is delete 1 row
        this.Members.splice(i, 1);
      })
    }
  }

}
