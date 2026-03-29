from flask import Flask, render_template, jsonify, request, Response
from flask_cors import CORS  # Import CORS for handling cross-origin requests
import cv2

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

# Replace this with your actual camera stream or video feed URL
camera_feed_url = 0  # 0 for default camera, or replace with a URL

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/move', methods=['POST'])
def move_robot():
    direction = request.json.get('direction')
    # Here you can add your logic to control the robot
    print(f'Moving robot {direction}')
    
    # Return a JSON response
    return jsonify({"status": "success", "direction": direction})

def generate_frames():
    """Video streaming generator function."""
    cap = cv2.VideoCapture(camera_feed_url)
    while True:
        success, frame = cap.read()
        if not success:
            break
        else:
            # Encode the frame in JPEG format
            ret, buffer = cv2.imencode('.jpg', frame)
            frame = buffer.tobytes()
            # Concatenate frame with boundary to support streaming
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

    cap.release()

@app.route('/video_feed')
def video_feed():
    """Video streaming route. Put this in the src attribute of an img tag."""
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == '_main_':
    app.run(host='0.0.0.0', port=5000,debug=True)