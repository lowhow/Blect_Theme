<?php
/**
 * @link http://php.net/manual/en/function.array-push.php
 */
class Timer
{
        private $start;
        private $end;

        public function timer()
        {
                $this->start = microtime(true);
        }

        public function Finish()
        {
                $this->end = microtime(true);
        }

        private function GetStart()
        {
                if (isset($this->start))
                        return $this->start;
                else
                        return false;
        }

        private function GetEnd()
        {
                if (isset($this->end))
                        return $this->end;
                else
                        return false;
        }

        public function GetDiff()
        {
                return $this->GetEnd() - $this->GetStart();
        }

        public function Reset()
        {
                $this->start = microtime(true);
        }

}