// Upload file
class Upload{
	constructor(selector){
		this.root = document.querySelector(selector);
		//container upload
		this.obj = document.createElement('div');
		this.obj.setAttribute('id', 'upload');
        this.obj.setAttribute('class', 'col-md-12');
		this.root.appendChild(this.obj);
		//input object
		this.input = document.createElement('input');
		this.input.setAttribute('type', 'file');
        this.input.setAttribute('name', 'files[]');
		this.input.setAttribute('multiple', 'multiple');
        this.input.setAttribute('accept', '.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.zip');
		this.input.setAttribute('id', 'file-upload');
		this.input.setAttribute('class', 'btn btn-success');
		this.input.setAttribute('data-maxfile','10');
		this.obj.appendChild(this.input);
		//error div
		this.error = document.createElement('div');
		this.error.setAttribute('class', 'error-file');
		this.obj.appendChild(this.error);
		//warning div
		this.warning = document.createElement('div');
		this.warning.setAttribute('class', 'warning-file');
		this.obj.appendChild(this.warning);
		//thumbs container
		this.thumbs = document.createElement('div');
		this.thumbs.setAttribute('class', 'files');
		this.obj.appendChild(this.thumbs);
		//download icon
		this.icon = document.createElement('i');
		this.icon.setAttribute('class', 'fa-solid fa-upload');
		this.icon.setAttribute('id', 'icon');
		this.obj.appendChild(this.icon);
		//message div
		this.message = document.createElement('div');
		this.message.setAttribute('class', 'message');
		this.message.innerText = 'Kéo thả file vào đây hoặc';
		this.obj.appendChild(this.message);
		//button
		this.btn = document.createElement('div');
		this.btn.setAttribute('id', 'btn');
		this.btn.innerText = 'Chọn file từ thiết bị';
		this.obj.appendChild(this.btn);
		//upload button
		this.upload = document.createElement('button');
		this.upload.setAttribute('id', 'upload-btn');
		this.upload.innerText = 'Upload';
		this.root.appendChild(this.upload);
        //note type file
        this.note = document.createElement('div');
		this.note.setAttribute('class', 'desc');
		this.note.innerText = 'Chỉ cho upload định dạng file: doc, docx, xls, xlsx, ppt, pptx, pdf, zip với dung lượng < 20MB';
		this.obj.appendChild(this.note);
		//adding event listeners
		this.input.addEventListener('change', this.__fileSelectHandler__, false);
		this.obj.addEventListener('click', () => {this.input.click()}, false);
		this.obj.addEventListener('dragover', this.__fileDragHover__, false);
		this.obj.addEventListener('dragleave', this.__fileDragHover__, false);
		this.obj.addEventListener('drop', this.__fileSelectHandler__, false);
		this.upload.addEventListener('click', this.__fileSelectHandle__, false);
		//file list
		this.files = [];
		this.sizeLimit = this.root.dataset.maxsize?parseFloat(this.root.dataset.maxsize):5;
		this.aboveLimit = [];
	}

	__fileDragHover__  = (e) => {
		e.stopPropagation();
		e.preventDefault();

		this.obj.className = (e.type === 'dragover' ? 'hover' : '');
	}

	__fileSelectHandler__ = (e) => {
		var files = e.target.files || e.dataTransfer.files;
		this.__fileDragHover__(e);
		this.error.style.display = 'none';
		this.message.style.display = 'none';
		this.upload.style.display = 'none';

		var name;

		for (var i = 0, file; file = files[i]; i++) {
			name = this.__parseFile__(file);
			if (name != undefined) {this.aboveLimit.push(name)}
		}
		this.__warning__();
		e.stopPropagation();
		e.preventDefault();
		this.input.value = files.name;
	}

	__warning__ = () => {
		if (this.aboveLimit.length){
			var i = document.createElement('i');
			i.setAttribute('class', 'fa fa-exclamation-triangle');
			this.warning.textContent = "";
			this.warning.appendChild(i);
			this.warning.appendChild(document.createTextNode(' File (' + this.aboveLimit.join(', ') + ') vượt quá kích thước tối đa ' + this.sizeLimit + 'MB'));
			this.warning.style.display = 'block';
		} else {
			this.warning.style.display = 'none';
		}
	}

	__parseFile__ (file){
			this.icon.style.display = "none";
			this.message.style.display = "none";
			this.btn.style.display = "inline-block";
			var div = document.createElement('div');
			div.setAttribute('class', 'file-thumb');
			this.thumbs.appendChild(div);
            var filename = document.createElement('div');
			filename.setAttribute('class', 'filename');
            filename.innerText= file.name;
			div.appendChild(filename);
			var prog = document.createElement('div');
			prog.setAttribute('class', 'progress');
			div.appendChild(prog);
			var fill = document.createElement('div');
			fill.setAttribute('class', 'fill');
			prog.appendChild(fill);
			var val = document.createElement('div');
			val.setAttribute('class', 'value');
			val.innerText = '0%';
			prog.appendChild(val);
			var i = document.createElement('i');
			i.setAttribute('class', 'fa-solid fa-circle-xmark');
			div.appendChild(i);
			//append file to the list
			var obj = {
				file: file,
				node: div,
			};
			//binding click event to close
			i.addEventListener('click', (event) => {
				event.stopPropagation();
				event.preventDefault();
				this.thumbs.removeChild(div);
				var index = this.files.indexOf(obj);
				if (index >= 0){
					this.files.splice(index, 1);
				}
				isEmpty();
			}, false);
			if (file.size <= this.sizeLimit * 1024 * 1024){
				this.files.push(obj);
				this.upload.style.display = "none";
			} else{
				var box = document.createElement('div');
				box.setAttribute('class', 'status');
				var icon = document.createElement('i');
				div.appendChild(box);
				box.appendChild(icon);
				icon.setAttribute('class', 'fa fa-exclamation-triangle');
				icon.style.color = 'orange';
				i.addEventListener('click', (event) => {
					event.stopPropagation();
					event.preventDefault();
					this.aboveLimit.splice(this.aboveLimit.indexOf(file.name), 1);
					this.__warning__();
				}, false);
				return file.name
			}
	}
}

var upload = new Upload('#multi-file-upload');

