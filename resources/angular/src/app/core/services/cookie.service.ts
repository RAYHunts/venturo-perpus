import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CookieService {

  constructor() { }

  /**
   * Returns the cookie value by name
   * @param name cookie name
   */
  public getCookie(name: string) {
    if (!name) { return null; }
    const nameEQ = name + '=';
    const ca = document.cookie.split(';');
    // tslint:disable-next-line: prefer-for-of
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) === ' ') { c = c.substring(1, c.length); }
      if (c.indexOf(nameEQ) === 0) { return c.substring(nameEQ.length, c.length); }
    }
    return null;
  }

  /**
   * Deletes the cookie with given name
   * @param name cookie name
   * @param path path of the domain
   */
  public deleteCookie(name: string) {
    this.setCookie(name, '', -1);
  }

  /**
   * Creates/sets the cookie
   * @param name name of cookie
   * @param value cookie value
   * @param days validity in days
   */
  public setCookie(name: string, value: string, days: number) {
    let expires = '';
    if (days) {
      const date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = '; expires=' + date.toUTCString();
    }
    document.cookie = name + '=' + value + expires + '; path=/';
  }
}
