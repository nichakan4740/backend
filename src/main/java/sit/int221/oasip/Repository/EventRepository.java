package sit.int221.oasip.Repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import sit.int221.oasip.Entity.Event;

import java.util.List;

public interface EventRepository extends JpaRepository<Event, Integer> {
//    @Query(value = "select * from Event e join Eventcategory ec where ec.eventCategoryName = 'Project Management Clinic' ")
//    public List<Event> findAll(String keyword);
}
