package sit.int221.oasip.Repository;

import org.springframework.data.jpa.repository.JpaRepository;
import sit.int221.oasip.Entity.Event;

public interface EventRepository extends JpaRepository<Event, Integer> {
}
