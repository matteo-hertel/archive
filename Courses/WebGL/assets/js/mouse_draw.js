function WebGLDraw() {
    var self = this;
    //references
    this.gl;
    this.program;
    this.old;
    this.picker = $('#colourPicker');
    this.slider = $('#slider1');
    this.emptyCanvas = $('#emptyCanvas');

    //canvas
    this.canvas = $("#gl-canvas");
    this.canvasHeight = this.canvas.outerHeight();
    this.canvasWidth = this.canvas.outerWidth();


    //flags
    this.isPressed = 0;
    this.currentBuffer;
    this.currentColour = [0, 1, 0, 1];

    //lists/arrays
    this.points = [];
    this.buffers = [];
    this.buffersSizes = [];
    this.colours = [];

    //modifier
    this.lineWidth = 1;
    this.multiplier = 0.001;
    this.vectorUP = vec3(0, 0, 1);

    this.bindEvents = function() {
            self.bindColourPicker();

            self.slider.slider({
                tooltip_position: "bottom"
            }).on('slide', self.changeLine);

            self.picker.on("changeColor", self.setColour);

            self.canvas.on("mousemove", self.mouseMove);

            self.canvas.on("contextmenu", function(e) {
                return false;
            });
            self.canvas.on("mousedown mouseup", self.togglePressed)
            self.canvas.on("touchstart touchend", self.togglePressed)
            self.emptyCanvas.on("click", self.cleanCanvas);
            self.canvas[0].addEventListener("touchmove", self.touchMove, false)
        }
        /**
         * Plain jQuery does not have offsetX and offsetY
         * so we need to use the vanilla add event listener
         * and get the offsetX and offsetY with a simple function
         */
    this.touchMove = function(e) {
        if (self.isPressed) {
            var touch = event.touches[0];
            var newEvent = {
                offsetX: touch.pageX - self.canvas.offset().left,
                offsetY: touch.pageY - self.canvas.offset().top
            }

            self.move(newEvent);
        }
    }

    this.mouseMove = function(e) {
        if (self.isPressed) {
            self.move(e);
        }
    }

    this.cleanCanvas = function() {
        self.points = [];
        self.buffers = [];
        self.buffersSizes = [];
        self.colours = [];
    }

    this.changeLine = function(e) {
        self.lineWidth = e.value;
    }

    this.bindColourPicker = function() {
        self.picker.colorpicker({

        });
    }

    this.convertToCoordinate = function(x, y) {

        var mapX = -1 + (2 * (x / self.canvasWidth));

        var mapY = 1 - (2 * (y / self.canvasHeight));

        return [mapX, mapY];
    }

    this.togglePressed = function(e) {
        e.preventDefault();
        self.isPressed = !self.isPressed;
        if (!self.isPressed) {

            if (self.points.length) {
                self.buffers.push(self.currentBuffer);
                self.buffersSizes.push(self.points.length);
                self.colours.push(self.currentColour);
            }
            self.resetVars();
        }
    }

    this.resetVars = function() {
        self.currentBuffer = null;
        self.old = null;
        self.points = [];
    }

    this.render = function() {
        self.gl.clear(self.gl.COLOR_BUFFER_BIT);

        //drawing stored vertex buffer
        //neede variables
        var vPosition;
        var loc;

        //looping old lines

        for (b = 0; b < self.buffers.length; b++) {
            self.buffers[b].bind();
            vPosition = self.gl.getAttribLocation(self.program, "vPosition");
            loc = self.gl.getUniformLocation(self.program, "colour");
            self.gl.uniform4fv(loc, self.colours[b]);
            self.gl.vertexAttribPointer(vPosition, 2, self.gl.FLOAT, false, 0, 0);
            self.gl.enableVertexAttribArray(vPosition);
            self.gl.drawArrays(self.gl.TRIANGLE_STRIP, 0, self.buffersSizes[b] / 2);
        }

        //drawing current vertex buffer
        if (self.currentBuffer) {
            self.currentBuffer.bind();
            vPosition = self.gl.getAttribLocation(self.program, "vPosition");
            self.gl.vertexAttribPointer(vPosition, 2, self.gl.FLOAT, false, 0, 0);
            loc = self.gl.getUniformLocation(self.program, "colour");
            self.gl.uniform4fv(loc, self.currentColour);
            self.gl.enableVertexAttribArray(vPosition);
            self.gl.drawArrays(self.gl.TRIANGLE_STRIP, 0, self.points.length / 2);
        }

        requestAnimFrame(self.render);
    }

    this.move = function(e) {
        try {
            if (!self.currentBuffer) {
                self.currentBuffer = new Buffer(self.gl, self.gl.ARRAY_BUFFER);
            }
            //remapping points and binding buffer
            var newPoint = self.convertToCoordinate(e.offsetX, e.offsetY);
            self.currentBuffer.bind();

            if (self.old) {

                var delta = [newPoint[0] - self.old[0], newPoint[1] - self.old[1]];
                //converting to a 3d vector
                var delta3 = normalize(vec3(delta[0], delta[1], 0.0));
                var perp3_v = scale(self.lineWidth * self.multiplier, normalize(cross(delta3, self.vectorUP)));

                if (self.points.length > 1) {
                    //computing the new point
                    var p1 = [newPoint[0] - perp3_v[0],
                        newPoint[1] - perp3_v[1]
                    ];

                    var p2 = [newPoint[0] + perp3_v[0],
                        newPoint[1] + perp3_v[1]
                    ];
                    self.points.push(p1[0], p1[1],
                        p2[0], p2[1])
                } else {
                    //compute the base of the strip
                    var p1 = [self.old[0] + perp3_v[0],
                        self.old[1] + perp3_v[1]
                    ];

                    var p2 = [self.old[0] - perp3_v[0],
                        self.old[1] - perp3_v[1]
                    ];

                    //compute the new point
                    var p3 = [newPoint[0] + perp3_v[0],
                        newPoint[1] + perp3_v[1]
                    ];

                    var p4 = [newPoint[0] - perp3_v[0],
                        newPoint[1] - perp3_v[1]
                    ];

                    self.points.push(p2[0], p2[1],
                        p1[0], p1[1],
                        p4[0], p4[1],
                        p3[0], p3[1]);
                }

                //uploading the point
                self.currentBuffer.upload(self.points, self.gl.DYNAMIC_DRAW);
            }
            //storing the current position
            self.old = newPoint;
        } catch (exc) {
            console.log(exc);
        }
    }

    //trigger for the color picker, setting the color and normalizing it
    this.setColour = function(e) {
        var rgb = e.color.toRGB();
        self.currentColour = [rgb.r / 255, rgb.g / 255, rgb.b / 255, 1.0];
    }
    this.bootstrap = function() {
        //  Configure WebGL
        self.gl = WebGLUtils.setupWebGL(self.canvas[0]);
        if (!self.gl) {
            alert("WebGL isn't available");
        }
        self.gl.viewport(0, 0, self.canvasWidth, self.canvasHeight);
        self.gl.clearColor(0, 0, 0, 0.0);

        //  Load shaders and initialize attribute buffers
        self.program = initShaders(self.gl, "vertex-shader", "fragment-shader");
        self.gl.useProgram(self.program);
        self.bindEvents();
        //kicking the render
        self.render();

    };
    this.bootstrap();
}


new WebGLDraw();
