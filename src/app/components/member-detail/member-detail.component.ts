import { Component, OnInit, NgZone } from '@angular/core';
import { Router, ActivatedRoute } from "@angular/router";
import { MemberService } from "./../../service/member.service";
import { FormGroup, FormBuilder } from "@angular/forms";

@Component({
  selector: 'app-member-detail',
  templateUrl: './member-detail.component.html',
  styleUrls: ['./member-detail.component.css']
})
export class MemberDetailComponent implements OnInit {

  getId: any;
  updateForm: FormGroup;

  constructor(
    public formBuilder: FormBuilder,
    private router: Router,
    private ngZone: NgZone,
    private activateRoute: ActivatedRoute,
    private memberService: MemberService
  ) {
    this.getId = this.activateRoute.snapshot.paramMap.get('id');

    this.memberService.getMember(this.getId).subscribe((res) => {
      this.updateForm.setValue({
        em_name: res['member_name'],
        em_datetime: res['member_datetime']
      })
    })

    this.updateForm = this.formBuilder.group({
      em_name: [''],
      em_datetime: ['']
    })
  }

  ngOnInit(): void {
  }

  onUpdate(): any {
    this.memberService.updateMember(this.getId, this.updateForm.value).subscribe(() => {
      console.log('Data updated successfully');
      this.ngZone.run(() => this.router.navigateByUrl('/member-list'))
    }, (err) => {
      console.log(err);
    })
  }

}
