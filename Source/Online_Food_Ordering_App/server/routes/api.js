const express = require('express');
const router = express.Router();
const mongoose = require('mongoose');
const User = require('../models/user');
const Hotel = require('../models/hotel');
const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');
const verifyToken = require('./verifyToken');
require('dotenv').config();


mongoose.connect(process.env.database_connect, { useNewUrlParser: true, useUnifiedTopology: true }) // Database connection is being taking place
  .then(() => { 
    console.log("database connected");
  })
  .catch(err => console.log(err));
// redirect to login page
router.get('/', (req, res) => {
    res.send('Redirecting to login page');
});

router.post('/register', async(req, res) => {
    let inputData = req.body;
    // checking if the username is already registered or not
    const isEmailExist = await User.findOne({isEmail: inputData.isEmail});
    // find one method is used to find only one single address
    if (isEmailExist) return res.status(400).send("User already registered");

    // encrypting password
    const salt = await bcrypt.genSalt(10);
    const hashedPassword = await bcrypt.hash(req.body.password, salt);

    // register a new user
    const newUser = new User({
        isEmail: req.body.isEmail,
        username: req.body.username,
        password: hashedPassword
    });

    // saving the user details
    newUser.save()
        .then((registeredUser) => {
            let payload = { subject: registeredUser.id};
            let token = jwt.sign(payload, process.env.SECRET_KEY);
            res.status(200).send({token, username: registeredUser.username, isEmail: registeredUser.isEmail, userId: registeredUser.id});
        })
        .catch((error) => {console.log(error); res.status(400).send(error)});
    
});
// this api will login the user
router.post('/login', async(req, res) => {
    let inputData = req.body;

    // checking if the email is registered
    const user = await User.findOne({isEmail: inputData.isEmail});
    if (!user) return res.status(400).send("user email doesn't exist!");

    // verifying the password
    const Password = await bcrypt.compare(inputData.password, user.password);
    if(!Password) return res.status(400).send("Incorrect Password!");

    // creating a session
    let payload = { subject: user.id};
    let token = jwt.sign(payload, process.env.SECRET_KEY);
    return res.status(200).send({token, username: user.username, isEmail: user.isEmail, userId: user.id});
});
// getting a list of hotels from the database
router.get('/hotels', verifyToken, async (req, res) => {
    try{
        const hotels = await Hotel.find();
        res.json(hotels);
    } catch(err) {
        res.status(404).send(`request is not processed - ${err}`);
    }
});

// finding selected hotel using hotel ID 
router.get('/hotels/:hotelId', verifyToken, async (req, res) => {
    try{
        const hotel = await Hotel.findOne({id: req.params.hotelId});
        res.json(hotel);
    } catch(err) {
        res.status(404).send(`request is not processed - ${err}`);
    }
});
 // retriving the order of the specific user
router.get('/order/:userId', verifyToken, async (req, res) => {

    const user = await User.findById(req.params.userId);
    if (!user) return res.status(400).send("User not found");
    return res.status(200).send({orders: user.orders});
});

//submitting the order
router.post('/order/:userId', verifyToken, async(req, res) => {

    const user = await User.findById(req.params.userId);
    if (!user) return res.status(400).send("User not found");
//updating the order into the user profile
    User.updateOne(
        { _id: req.params.userId },
        { $push: {
            orders: req.body
            }
        },
        
        function(err, success) {
            if(err){
                return res.status(500).send(err)
            }
            else {
                return res.status(200).send(success);
            }
        }
    )
});

module.exports = router;