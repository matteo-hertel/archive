"use strict";

function FollowMouse() {
    var self = this;

    this.canvas = $("#gl-canvas");
    this.canvasHeight = this.canvas.outerHeight();
    this.canvasWidth = this.canvas.outerWidth();
    this.gl;
    this.points = [];
    self.vertices = [
        [-0.1, -0.1], //1
        [-0.1, 0.1], //2
        [0.1, -0.1], //4
        [0.1, 0.1] //3

    ];
    this.newVertices = this.vertices;
    this.iterations = 4;
    this.twistFactor = 2.0;
    this.slider1 = $("#slider1");
    this.slider2 = $("#slider2");
    this.slider1Counter = $("#slider1Counter");
    this.slider2Counter = $("#slider2Counter");
    this.isPressed = false;
    this.bindEvents = function() {
        self.canvas.on("mousemove", function(e) {
            if (!self.isPressed) {
                self.convertToCoordinate(e.offsetX, e.offsetY);
            }
        })
        self.canvas.on("mousedown mouseup", function(e) {
            self.togglePressed();
        })
    }

    this.getOffset = function(x, y) {

        self.newVertices = [
            vec2(x -0.1  , y -0.1 ),
            vec2(x -0.1  , y+ 0.1 ),
            vec2(x + 0.1, y -0.1 ),
            vec2(x +0.1, y + 0.1 ),
        ];
        self.preprocess();
    }

    this.convertToCoordinate = function(x, y){

        var mapX = -1 + (2*(x/self.canvasWidth));

        var mapY = 1 - (2*(y/self.canvasHeight));

        self.getOffset(mapX, mapY);
    }

    this.togglePressed = function() {
        self.isPressed = !self.isPressed;
    }

    this.preprocess = function() {
        self.points = [];
        self.process();
        self.render();
    }

    this.process = function() {

        self.points = self.newVertices;

    }

    this.triangle = function(a, b, c) {
        self.points.push(a, b, c);
    }

    this.euclidianDiatance = function(v1, v2) {
        var res = Math.pow((v1[0] - v2[0]), 2) + Math.pow((v1[1] - v2[1]), 2);
        res = Math.sqrt(res);
        return res;
    }

    this.halfPoint = function(v1, v2) {
        var v = [v1[0] + ((v2[0] - v1[0]) * 0.5), v1[1] + ((v2[1] - v1[1]) * 0.5)];
        return v
    }

    this.rotation = function(vec, angle) {
        var vec2 = [vec[0] - self.center[0], vec[1] - self.center[1]];
        var res = [vec2[0] * Math.cos(angle) - vec2[1] * Math.sin(angle),
            vec2[0] * Math.sin(angle) + vec2[1] * Math.cos(angle)
        ];
        res = [res[0] + self.center[0], res[1] + self.center[1]];
        return res;

    }

    this.subdivide = function(v1, v2, v3, iteration) {
        //check if we need to break the recursion
        if (iteration == 0) {

            self.triangle(v1, v2, v3);
            return;
        }

        //subdivide the sides
        var h1 = self.halfPoint(v1, v2);
        var h2 = self.halfPoint(v2, v3);
        var h3 = self.halfPoint(v3, v1);

        self.subdivide(v1, h1, h3, iteration - 1);
        self.subdivide(h1, v2, h2, iteration - 1);
        self.subdivide(h3, h2, v3, iteration - 1);
        self.subdivide(h1, h2, h3, iteration - 1);

    }

    this.render = function() {
        //  Load shaders and initialize attribute buffers

        var program = initShaders(self.gl, "vertex-shader", "fragment-shader");
        self.gl.useProgram(program);

        // Load the data into the GPU

        var bufferId = self.gl.createBuffer();
        self.gl.bindBuffer(self.gl.ARRAY_BUFFER, bufferId);
        self.gl.bufferData(self.gl.ARRAY_BUFFER, flatten(self.points), self.gl.STATIC_DRAW);

        // Associate out shader variables with our data buffer

        var vPosition = self.gl.getAttribLocation(program, "vPosition");
        self.gl.vertexAttribPointer(vPosition, 2, self.gl.FLOAT, false, 0, 0);
        self.gl.enableVertexAttribArray(vPosition);

        self.gl.clear(self.gl.COLOR_BUFFER_BIT);
        self.gl.drawArrays(self.gl.TRIANGLE_STRIP, 0, self.points.length);
    }

    this.bootstrap = function() {
        self.gl = WebGLUtils.setupWebGL(self.canvas[0]);
        if (!self.gl) {
            alert("WebGL isn't available");
        }
        self.bindEvents();
        self.process();
        //
        //  Configure WebGL
        //
        self.gl.viewport(0, 0, self.canvas.outerWidth(), self.canvas.outerHeight());
        self.gl.clearColor(0,0,0,0);

        self.render();

    };
    this.bootstrap();
}

new FollowMouse();
