var jsonServer = require('json-server');
const mysql = require('mysql2');

var server = jsonServer.create();

server.use(jsonServer.defaults());

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'allison',              
    password: 'Allison1124Web!',   
    database: 'serverdatabase'    
});

connection.connect((err) => {
    console.log('Connected to MySQL database');
});



server.get('/api/static', function (req, res) {
    const query = 'SELECT * FROM static_data';  

    connection.query(query, (err, results) => {

        res.jsonp(results); 
    });
});

server.get('/api/static/:id', function (req, res) {
    const id = parseInt(req.params.id);
    const query = 'SELECT * FROM static_data WHERE id = ?'; 

    connection.query(query, [id], (err, results) => {
        if (err) {
            console.error('Error fetching data from MySQL:', err);
            res.status(500).json({ message: 'Internal server error' });
            return;
        }

        if (results.length > 0) {
            res.jsonp(results[0]); 
        } else {
            res.status(404).json({ message: `User with id ${id} not found` });
        }
    });
});

server.post('/api/static', function (req, res) {
  const newData = req.body;

  const query = `
    INSERT INTO static_data 
      (session_id, timestamp, user_agent, language, cookies_enabled, javascript_enabled,
       screen_width, screen_height, window_width, window_height,
       connection_type, images_enabled, css_enabled)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  `;

  const values = [
    newData.session_id,
    newData.timestamp,
    newData.user_agent,
    newData.language,
    newData.cookies_enabled,
    newData.javascript_enabled,
    newData.screen_width,
    newData.screen_height,
    newData.window_width,
    newData.window_height,
    newData.connection_type,
    newData.images_enabled,
    newData.css_enabled
  ];

  connection.query(query, values, (err, results) => {
    if (err) {
      console.error('Error inserting data into MySQL:', err);
      res.status(500).json({ message: 'Internal server error' });
      return;
    }

    newData.id = results.insertId;
    res.status(201).json(newData);
  });
});

server.delete('/api/static/:id', function (req, res) {
    const id = parseInt(req.params.id);
    const query = 'DELETE FROM static_data WHERE id = ?';

    connection.query(query, [id], (err, results) => {
        if (err) {
            console.error('Error deleting data from MySQL:', err);
            res.status(500).json({ message: 'Internal server error' });
            return;
        }

        if (results.affectedRows > 0) {
            res.status(200).json({ message: `Record with id ${id} deleted from static_data` });
        } else {
            res.status(404).json({ message: `Record with id ${id} not found in static_data` });
        }
    });
});

server.put('/api/static/:id', function (req, res) {
    const id = parseInt(req.params.id);
    const updatedUser = req.body;
    const query = 'UPDATE users SET name = ?, email = ?, age = ? WHERE id = ?';

    connection.query(query, [updatedUser.name, updatedUser.email, updatedUser.age, id], (err, results) => {
        if (err) {
            console.error('Error updating data in MySQL:', err);
            res.status(500).json({ message: 'Internal server error' });
            return;
        }

        if (results.affectedRows > 0) {
            res.status(200).jsonp(updatedUser);
        } else {
            res.status(404).json({ message: `User with id ${id} not found` });
        }
    });
});
server.get('/api/performance', function (req, res) {
    const query = `
        SELECT 
	    id,
	    session_id, 
            page_load_start, 
            page_load_end, 
            total_load_time 
        FROM performance_data
    `;

    connection.query(query, (err, results) => {
        if (err) {
            console.error('Error fetching performance data from MySQL:', err);
            res.status(500).json({ message: 'Internal server error' });
            return;
        }

        res.jsonp({ data: results });
    });
});

server.get('/api/activity', function (req, res) {
    const query = `
        SELECT 
            id,
            session_id,
            error_count,
            mouse_movements_count,
            clicks_count,
            scrolls_count,
            key_events_count,
            idle_periods_count,
            created_at
        FROM activity_data
    `;

    connection.query(query, (err, results) => {
        if (err) {
            console.error('Error fetching activity data from MySQL:', err.message);
            res.status(500).json({ message: 'Internal server error', error: err.message });
            return;
        }

        res.jsonp({ data: results });
    });
});


var router = jsonServer.router('db.json');
server.use(router);

server.listen(3000, () => {
    console.log('Server is running on http://localhost:3000');
});

