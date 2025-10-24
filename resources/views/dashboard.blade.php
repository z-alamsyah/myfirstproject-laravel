<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar a {
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .navbar a:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .welcome-card h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 32px;
        }
        
        .welcome-card p {
            color: #666;
            font-size: 18px;
            line-height: 1.6;
        }
        
        .user-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }
        
        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .alert-success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <div class="navbar">
        <h1>Dashboard</h1>
        <a href="{{ route('logout') }}">Logout</a>
    </div>
    
    {{-- Container --}}
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="welcome-card">
            <h2>Selamat Datang! 👋</h2>
            <p>Anda berhasil login ke sistem.</p>
            
            <div class="user-info">
                <h3>🔐 User Information (JWT Authenticated)</h3>
                <p><strong>Username:</strong> {{ $username }}</p>
                <p><strong>User ID:</strong> {{ session('user_id') }}</p>
            </div>

            @if($jwt_token)
                <div class="jwt-token-section" style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 20px; border: 2px solid #e9ecef;">
                    <h3 style="color: #495057; margin-bottom: 15px;">🔑 JWT Token Information</h3>

                    <div style="background: white; padding: 15px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #28a745;">
                        <p style="margin: 0; font-family: 'Courier New', monospace; font-size: 12px; word-break: break-all;">
                            <strong>Token:</strong> {{ $jwt_token }}
                        </p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                        <div style="background: white; padding: 15px; border-radius: 5px; border-left: 4px solid #007bff;">
                            <p style="margin: 0;"><strong>🌐 API Endpoint:</strong></p>
                            <p style="margin: 5px 0 0 0; font-family: 'Courier New', monospace; font-size: 12px;">POST /api/auth/login</p>
                        </div>

                        <div style="background: white; padding: 15px; border-radius: 5px; border-left: 4px solid #ffc107;">
                            <p style="margin: 0;"><strong>📡 Profile Endpoint:</strong></p>
                            <p style="margin: 5px 0 0 0; font-family: 'Courier New', monospace; font-size: 12px;">GET /api/auth/profile</p>
                        </div>
                    </div>

                    <div style="margin-top: 15px; text-align: left;">
                        <p style="margin: 0; font-size: 14px; color: #6c757d;">
                            <strong>📝 Usage:</strong> Include this token in your API requests using the Authorization header:
                        </p>
                        <p style="margin: 5px 0 0 0; font-family: 'Courier New', monospace; font-size: 12px; background: #e9ecef; padding: 5px; border-radius: 3px;">
                            Authorization: Bearer {{ substr($jwt_token, 0, 30) }}...
                        </p>
                    </div>
                </div>
            @endif

            <div style="background: #d1ecf1; padding: 15px; border-radius: 5px; margin-top: 20px; border-left: 4px solid #0c5460;">
                <h4 style="color: #0c5460; margin-bottom: 10px;">🔒 Security Features Implemented:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #0c5460;">
                    <li>✅ Passwords are now properly hashed using bcrypt</li>
                    <li>✅ JWT tokens for secure API authentication</li>
                    <li>✅ Token expiration and refresh capabilities</li>
                    <li>✅ Secure logout with token invalidation</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>