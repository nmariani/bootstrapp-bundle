<?php
/**
 * (c) 2012-2014 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani
 * @date 10/03/2014 16:06
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nmariani\Bundle\BootstrappBundle\Form\Extension\Core\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class Hour2400ToHour1200Transformer implements DataTransformerInterface
{
    const CASE_LOWER = 'lower';
    const CASE_UPPER = 'upper';

    /**
     * @var string
     */
    protected $case;


    /**
     * @param string|null $case
     */
    public function __construct($case = null)
    {
        $this->case = self::CASE_UPPER;

        if ($case) {
            $this->setCase($case);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (is_string($value) && !empty($value)) {
            $data = $this->parse($value);
            if((null !== $data['hour']) && (null == $data['meridiem'])) {
                if ($data['hour'] >= 12) {
                    $value = preg_replace('/^'.$data['hour'].'\:/', ($data['hour'] - 12).':', $value, 1);
                    $value .= $this->case == self::CASE_LOWER ? ' pm' : ' PM';
                } else {
                    $value .= $this->case == self::CASE_LOWER ? ' AM' : ' AM';
                }
            }
        }
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (is_string($value) && !empty($value)) {
            $data = $this->parse($value);
            if((null !== $data['hour']) && ('pm' == $data['meridiem'])) {
                if ($data['hour'] <= 12) {
                    $value = preg_replace('/^'.$data['hour'].'\:/', ($data['hour'] + 12).':', $value, 1);
                }
            }
            $value = trim(str_ireplace(['am', 'pm'], '', $value));
        }
        return $value;
    }

    /**
     * @param string $value
     * @return array
     */
    protected function parse($value)
    {
        $data = [
            'hour' => null,
            'meridiem' => null,
        ];

        if (is_string($value)) {
            preg_match('/(\d+)\:.*\s(am|pm)?/i', $value, $matches);
            if (isset($matches[1])) {
                $data['hour'] = $matches[1];
            }
            if (isset($matches[2])) {
                $data['meridiem'] = strtolower($matches[2]);
            }
        }

        return $data;
    }

    /**
     * Set transformer case (lower|upper)
     * @param string $case
     */
    public function setCase($case)
    {
        if (in_array($case, [self::CASE_LOWER, self::CASE_UPPER])) {
            $this->case = $case;
        }
    }
}