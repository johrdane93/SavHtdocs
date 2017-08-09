<?php

require 'B.php';

A::testSelf();
echo'<br>';

A::testStatic();

echo'<hr>';

B::testSelf();

echo'<br>';

B::testStatic();

echo'<hr>';
