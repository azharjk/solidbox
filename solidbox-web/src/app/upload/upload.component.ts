import { Component, ElementRef, ViewChild } from '@angular/core';

@Component({
  selector: 'app-upload',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})
export class UploadComponent {

  @ViewChild('inputFile')
  inputFile!: ElementRef<HTMLInputElement>;

  onUpload() {
    this.inputFile.nativeElement.click();
  }

  // FIXME: Do something with the file
  onFileChange(e: Event) {
    const target = e.target as HTMLInputElement;
    if (target.files) {
      const file = target.files[0];

      console.log(file);
    }
  }
}
