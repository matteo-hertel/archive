/**
 *
 * Thanks to Marco Giordano for the function
 */

function Buffer(gl, buffer_type) {
    var self = this;
    this.id;
    this.gl = gl;
    this.id = gl.createBuffer();
    this.type = buffer_type;

    /*
     * This function binds the buffer
     */
    this.bind = function() {
        self.gl.bindBuffer(self.type, self.id);
    }

    /*
     * This function is used to upload the data on the buffer
     * Should be of type Float32Array or UInt16Array etc
     */
    this.upload = function(data, draw_type) {
        draw_type = typeof draw_type !== 'undefined' ? draw_type : self.gl.STATIC_DRAW;
        self.bind();
        self.gl.bufferData(self.type,
            flatten(data),
            draw_type);
        if (self.gl.getError()) {
            console.log("ERROR IN UPLOADING DATA: " + self.type);
        }
    }

    this.uploadUInt16 = function(data) {
        //lets flatten it up as array Uint16
        var idx_size = data.length;
        var data16 = new Uint16Array(idx_size);
        for (i = 0; i < idx_size; i++) {
            data16[i] = data[i];
        }
        self.bind();
        self.gl.bufferData(self.type,
            data16,
            self.gl.STATIC_DRAW);
        if (self.gl.getError()) {
            console.log("ERROR IN UPLOADING DATA: " + self.type);
        }

    }
}
