import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { ToastService, AngularToastifyModule } from 'angular-toastify';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {userInfoForm : FormGroup;
  records :any
  submitted = false;
  IsCalling: boolean = false;
  constructor(private router:Router,private fb:FormBuilder,private http:HttpClient,private toastService: ToastService) { }
  ngOnInit(): void {
    this.userInfoForm = this.fb.group({
      name : ["", Validators.required],
      email : ["",[Validators.required, Validators.email]],
    })
    // Store records in a variable
    this.records = this.getRecords();
    console.log(this.infoFormControl)
  }

  // Insert form data
  submitForm(){
    this.submitted = true;
    if (this.userInfoForm.valid) {
      this.IsCalling = true;
      this.http.post('http://127.0.0.1:8080/api/create.php',this.userInfoForm.value).subscribe(()=>{
        this.userInfoForm.reset();
        this.toastService.success('Data saved successfylly!');
        this.records = this.getRecords();
        this.IsCalling = false;
        this.submitted = false;
      });
    }
  }
  // Get All records
   getRecords(){
    this.http.get('http://127.0.0.1:8080/api/display.php').subscribe((response)=>{
      this.records = response;
      console.warn('response',this.records);
    });
   }

  get infoFormControl() {
    return this.userInfoForm.controls;
  }
}
