import { Injectable } from '@angular/core';
import { catchError, map } from 'rxjs/operators';
import { Observable, throwError } from 'rxjs';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

export class Member {
  member_name!: String;
}

@Injectable({
  providedIn: 'root'
})
export class MemberService {

  // Slim Framework API
  REST_API: string = 'http://localhost/angular/project-angular/backend/rest_api/public/api/v1/member';

  // Http Header
  httpHeaders = new HttpHeaders().set("Content-Type", "application/json");

  constructor(private httpClient: HttpClient) { }


  // Add member
  addMember(data: Member): Observable<any> {
    let API_URL = `${this.REST_API}/add`;
    return this.httpClient.post(API_URL, data).pipe(catchError(this.handleError))
  }

  // Get all object
  getMembers(){
    let members_data = this.httpClient.get(`${this.REST_API}`);
    return members_data;
  }

  // Get single obkect
  getMember(member_id: any): Observable<any>{
    let API_URL = `${this.REST_API}/${member_id}`;
    return this.httpClient.get(API_URL, {headers: this.httpHeaders}).pipe(map((res:any) => {
      return res || {}
    }),
    catchError(this.handleError)
    )
  }

  // Update
  updateMember(member_id:any, data:any): Observable<any> {
    let API_URL = `${this.REST_API}/update/${member_id}`;
    return this.httpClient.put(API_URL, data, {headers: this.httpHeaders})
    .pipe(
      catchError(this.handleError)
    )
  }

  // Delete
  deleteMember(member_id:any): Observable<any>{
    let API_URL = `${this.REST_API}/delete/${member_id}`;
    return this.httpClient.delete(API_URL, {headers: this.httpHeaders})
    .pipe(
      catchError(this.handleError)
    )
  }

  // Make handleError method customize
  handleError(error: HttpErrorResponse) {
    let errorMessage = '';
    if (error.error instanceof ErrorEvent) {
      // Handle client error
      errorMessage = error.error.message;      
    } else {
      // Handle server error
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    console.log(errorMessage);
    return throwError(errorMessage);
  }
}
