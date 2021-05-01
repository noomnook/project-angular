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
      // console.log("Data APIService Debug >: " + JSON.stringify(res))
      this.Members = res;
    })
  }

  delete(member: any, i: any) {    
    if (window.confirm('Do you want to delete?')) {
      this.memberService.deleteMember(member.member_id).subscribe(res => {
        console.log(res)
        // splice 1 is delete 1 row
        // Learning splice 
        // https://medium.com/@rennerwin/%E0%B8%A1%E0%B8%B2%E0%B9%80%E0%B8%82%E0%B9%89%E0%B8%B2%E0%B9%83%E0%B8%88%E0%B8%84%E0%B8%A7%E0%B8%B2%E0%B8%A1%E0%B9%81%E0%B8%95%E0%B8%81%E0%B8%95%E0%B9%88%E0%B8%B2%E0%B8%87%E0%B8%A3%E0%B8%B0%E0%B8%AB%E0%B8%A7%E0%B9%88%E0%B8%B2%E0%B8%87-slice-%E0%B8%81%E0%B8%B1%E0%B8%9A-splice-%E0%B8%82%E0%B8%AD%E0%B8%87-array-%E0%B8%81%E0%B8%B1%E0%B8%99%E0%B9%80%E0%B8%96%E0%B8%AD%E0%B8%B0-e2edc45b322d
        this.Members.splice(i, 1);
      }, (err) => {
        console.log(err);
      })
    }
  }

}
