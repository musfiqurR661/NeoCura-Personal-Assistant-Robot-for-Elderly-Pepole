from flask import Flask, render_template, jsonify, request, Response
from flask_cors import CORS
import cv2
import json
import os
from datetime import datetime
import threading

app = Flask(__name__)
CORS(app)

# Camera feed URL
camera_feed_url = 0  # 0 for default camera

# Data storage file
DATA_FILE = 'health_data.json'
ACTIVITIES_FILE = 'activities.json'

# Load or initialize health data
def load_health_data():
    if os.path.exists(DATA_FILE):
        with open(DATA_FILE, 'r') as f:
            return json.load(f)
    return {'heart_rate': [], 'steps': [], 'recordings': []}

def save_health_data(data):
    with open(DATA_FILE, 'w') as f:
        json.dump(data, f, indent=2)

def load_activities():
    if os.path.exists(ACTIVITIES_FILE):
        with open(ACTIVITIES_FILE, 'r') as f:
            return json.load(f)
    return []

def save_activities(activities):
    with open(ACTIVITIES_FILE, 'w') as f:
        json.dump(activities, f, indent=2)

# Routes
@app.route('/')
def index():
    return render_template('index.html')

@app.route('/dashboard')
def dashboard():
    return render_template('dashboard.html')

@app.route('/services')
def services():
    return render_template('services.html')

@app.route('/move', methods=['POST'])
def move_robot():
    direction = request.json.get('direction')
    print(f'Moving robot {direction}')
    
    # Log activity
    activities = load_activities()
    activities.append({
        'type': 'robot_movement',
        'direction': direction,
        'timestamp': datetime.now().isoformat()
    })
    save_activities(activities)
    
    return jsonify({"status": "success", "direction": direction})

@app.route('/health/heart_rate', methods=['POST'])
def add_heart_rate():
    data = load_health_data()
    heart_rate = request.json.get('heart_rate')
    
    record = {
        'value': heart_rate,
        'timestamp': datetime.now().isoformat()
    }
    data['heart_rate'].append(record)
    save_health_data(data)
    
    # Log activity
    activities = load_activities()
    activities.append({
        'type': 'health_check',
        'metric': 'heart_rate',
        'value': heart_rate,
        'timestamp': datetime.now().isoformat()
    })
    save_activities(activities)
    
    return jsonify({"status": "success", "message": "Heart rate recorded"})

@app.route('/health/steps', methods=['POST'])
def add_steps():
    data = load_health_data()
    steps = request.json.get('steps')
    
    record = {
        'value': steps,
        'timestamp': datetime.now().isoformat()
    }
    data['steps'].append(record)
    save_health_data(data)
    
    # Log activity
    activities = load_activities()
    activities.append({
        'type': 'activity_log',
        'metric': 'steps',
        'value': steps,
        'timestamp': datetime.now().isoformat()
    })
    save_activities(activities)
    
    return jsonify({"status": "success", "message": "Steps recorded"})

@app.route('/health/data', methods=['GET'])
def get_health_data():
    return jsonify(load_health_data())

@app.route('/activities', methods=['GET'])
def get_activities():
    activities = load_activities()
    # Return last 50 activities
    return jsonify(activities[-50:])

@app.route('/emergency', methods=['POST'])
def emergency_call():
    action = request.json.get('action', 'SOS')
    print(f'EMERGENCY: {action}')
    
    activities = load_activities()
    activities.append({
        'type': 'emergency',
        'action': action,
        'timestamp': datetime.now().isoformat()
    })
    save_activities(activities)
    
    return jsonify({
        "status": "success",
        "message": "Emergency service contacted!",
        "action": action
    })

@app.route('/record', methods=['POST'])
def save_recording():
    recording_data = request.json.get('data')
    name = request.json.get('name', f'recording_{datetime.now().isoformat()}')
    
    data = load_health_data()
    data['recordings'].append({
        'name': name,
        'data': recording_data,
        'timestamp': datetime.now().isoformat()
    })
    save_health_data(data)
    
    return jsonify({"status": "success", "message": "Recording saved"})

def generate_frames():
    """Video streaming generator function."""
    cap = cv2.VideoCapture(camera_feed_url)
    while True:
        try:
            success, frame = cap.read()
            if not success:
                break
            ret, buffer = cv2.imencode('.jpg', frame)
            frame = buffer.tobytes()
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')
        except Exception as e:
            print(f"Error in video stream: {e}")
            break
    cap.release()

@app.route('/video_feed')
def video_feed():
    """Video streaming route."""
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True, threaded=True)
