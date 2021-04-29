import { Component, OnInit, NgZone } from '@angular/core';
import { Router } from '@angular/router';
import { MemberService } from './../../service/member.service';
import { FormGroup, FormBuilder } from '@angular/forms';

@Component({
  selector: 'app-add-member',
  templateUrl: './add-member.component.html',
  styleUrls: ['./add-member.component.css']
})
export class AddMemberComponent implements OnInit {

  memberForm: FormGroup;

  constructor(
    public formBuilder: FormBuilder,
    private router: Router,
    private ngZone: NgZone,
    private memberService: MemberService
  ) {
    this.memberForm = formBuilder.group({
      m_name: ['']
    })
  }

  ngOnInit(): void {
  }

  onSubmit(): any {
    this.memberService.addMember(this.memberForm.value)
      .subscribe(() => {
        console.log("Data added successfully");
        this.ngZone.run(() => this.router.navigateByUrl('/member-list'))
      }, (err) => {
        console.log(err);
      })
  }

}
