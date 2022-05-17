<?php
session_unset();
Header('Location: ' . $this->GetUrl('/home'));