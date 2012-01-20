<?PHP

namespace com\druid628;

abstract class BaseClass628 {

        /**
         * 
         * hooray for magic!!
         *
         * @param string $method
         * @param mixed $arguments
         * @return mixed 
         */
        public function __call($method, $arguments) 
        {
                try {
                        $verb = substr($method, 0, 3);
                        if (in_array($verb, array('set', 'get'))) {
                                $name = substr($method, 3);
                        }

                        if (method_exists($this, $verb)) {
                                if (property_exists($this, $name)) {
                                        return call_user_func_array(array($this, $verb), array_merge(array($name), $arguments));
                                } elseif (property_exists($this, lcfirst($name))) {
                                        return call_user_func_array(array($this, $verb), array_merge(array(lcfirst($name)), $arguments));
                                } else {
                                        throw new Exception("Variable  ($name)  Not Found");
                                }
                        } else {
                                throw new Exception("Function ($verb) Not Defined");
                        }
                } catch (Exception $e) {
                        printf("You done yucked up!");
                        var_dump($e);
                }
        }

        /**
         * 
         * standard getter
         *
         * @param string $fieldName
         * @return mixed 
         */
        public function get($fieldName) 
        {
                if (!property_exists($this, $fieldName)) {
                        trigger_error("Variable ($fieldName) Not Found", E_USER_ERROR);
                }

                return $this->$fieldName;
        }

        /**
         * standard setter
         *
         * @param string $fieldName
         * @param mixed $value
         * @return boolean 
         */
        public function set($fieldName, $value) 
        {
                if (!property_exists($this, $fieldName)) {
                        trigger_error("Variable ($fieldName) Not Found", E_USER_ERROR);
                }

                $this->$fieldName = $value;
                return true;
        }

        /**
         *
         * For some reason there is no lcfirst function but there 
         * is a ucfirst... oh well that's fixed. :)
         * 
         * @param string $string
         * @return string 
         */
        public function lcfirst($string) 
        {
                $string{0} = strtolower($string{0});
                return $string;
        }

        /**
         *
         * 
         * 
         * @param stdClass $obj
         * @param <Type> $class
         * @return <TypeOf> $class 
         * @see http://freebsd.co.il/cast/
         */
        public function cast($obj, $class) 
        {
                $reflectionClass = new ReflectionClass($class);
                if (!$reflectionClass->IsInstantiable()) {
                        throw new Exception($class . " is not instantiable!");
                }

                if ($obj instanceof $class) {
                        return $obj; // nothing to do.
                }

                // lets instantiate the new object
                $tmpObject = $reflectionClass->newInstance();

                $properties = Array();
                foreach ($reflectionClass->getProperties() as $property) {
                        $properties[$property->getName()] = $property;
                }

                // we'll take all the properties from the fathers as well
                // overwriting the old properties from the son as well if needed.
                $parentClass = $reflectionClass; // loop init
                while ($parentClass = $parentClass->getParentClass()) {
                        foreach ($parentClass->getProperties() as $property) {
                                $properties[$property->getName()] = $property;
                        }
                }

                // now lets see what we have set in $obj and transfer that to the new object
                $vars = get_object_vars($obj);
                foreach ($vars as $varName => $varValue) {
                        if (array_key_exists($varName, $properties)) {
                                $prop = $properties[$varName];
                                if (!$prop->isPublic()) {
                                        $prop->setAccessible(true);
                                }
                                $prop->setValue($tmpObject, $varValue);
                        }
                }

                return $tmpObject;
        }

        public function getPerformance()
        {
            $mem_usage = memory_get_peak_usage();
            if ($mem_usage < 1024) 
            {
                 echo $mem_usage." bytes"; 
            }elseif ($mem_usage < 1048576) 
            {
                 echo round($mem_usage/1024,2)." kilobytes"; 
            }else 
            {
                 echo round($mem_usage/1048576,2)." megabytes"; 
            }
        }

}
